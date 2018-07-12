# coding:utf-8

import logging
import os
import time
import unittest
import yaml

from selenium import webdriver
from selenium.webdriver.support.wait import WebDriverWait


class Test(unittest.TestCase):
    # @classmethod
    # def setUpClass(cls):
    #     print("setUpClass")
    #     # cls.initLogger(cls)
    #     # cls.loadConfig(cls)
    #     # cls.driver = webdriver.Firefox()
    #     # cls.importWallet(cls)
    #
    # @classmethod
    # def tearDownClass(cls):
    #     print("tearDownClass")
    #     cls.driver.quit()

    def setUp(self):
        print("setUp")
        self.initLogger()
        self.loadConfig()
        self.driver = webdriver.Firefox()

    def tearDown(self):
        print("tearDown")
        self.driver.quit()

    def initLogger(self):
        if not os.path.exists('logs'):
            os.mkdir('logs')

        del logging.root.handlers[:]
        del logging.root.filters[:]

        formatter = logging.Formatter(
            '>>>>> %(name)s %(levelname)-7s %(asctime)s [%(filename)s:%(funcName)s] %(lineno)d# %(message)s')

        dt = time.strftime("%Y-%m-%d_%H-%M-%S", time.localtime())

        self.logger = logging.getLogger('ELAPAY')
        self.logger.setLevel(logging.DEBUG)
        log_name = 'logs/run_log_' + dt + '.log'
        pwd = os.path.dirname(os.path.abspath(__file__))
        handler = logging.FileHandler(os.path.join(pwd, log_name), 'w', encoding='utf-8')
        handler.setFormatter(formatter)
        self.logger.addHandler(handler)

        ch = logging.StreamHandler()
        ch.setLevel(logging.DEBUG)
        ch.setFormatter(formatter)
        self.logger.addHandler(ch)
        return self.logger

    def loadConfig(self):
        f = open("config.yaml")
        self.config = yaml.load(f)
        self.getHttpRequest()
        f.close()

    def getHttpRequest(self):
        self.httpRequest = self.config['ElaWalletUrl'] + "&account=" + str(self.config['Parameter']['account']) \
            + "&address=" + self.config['Parameter']['address'] + "&memo=" + self.config['Parameter']['memo'] \
            + "&callback_url=" + self.config['Parameter']['callback_url'] + "&return_url=" + self.config['Parameter']['return_url']

    def getHttpRequestByAccount(self, account):
        self.httpRequest = self.config['ElaWalletUrl'] + "&account=" + str(account) \
            + "&address=" + self.config['Parameter']['address'] + "&memo=" + self.config['Parameter']['memo'] \
            + "&callback_url=" + self.config['Parameter']['callback_url'] + "&return_url=" + self.config['Parameter']['return_url']

    def importWallet(self):
        self.logger.info("----importWallet----")
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_id("restore"))
        self.driver.find_element_by_id('restore').click()

        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_class_name("ng-valid"))
        self.driver.find_element_by_class_name('ng-valid').send_keys(self.config['Wallet']['Mnemonic'])
        self.driver.find_element_by_name('requestPassword').send_keys(self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/div/div[5]/input').send_keys(
            self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/button').click()

    def addMemo(self, is_import_wallet=False):
        memo_xpath_tag = "/span[1]/span"
        input_xpath_tag = "/html/body/div[5]"
        if is_import_wallet:
            input_xpath_tag = "/html/body/div[6]"

        self.driver.find_element_by_xpath(
            '/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/ion-content/div/div/div[2]/a[2]' + memo_xpath_tag).click()
        WebDriverWait(self.driver, 10, 0.5).until(
            lambda x: x.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input'))
        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input').send_keys("add memo")
        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[3]/button[2]').click()

    def doPay(self, is_import_wallet=False):
        self.logger.info("----doPay----")
        time.sleep(15)

        self.addMemo(is_import_wallet)
        time.sleep(1)
        self.driver.find_element_by_xpath(
            '/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button').click()

        pre_title = "/html/body/div[5]"
        if is_import_wallet:
            pre_title = "/html/body/div[6]"
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath(pre_title + "/div/div[2]/input"))
        self.driver.find_element_by_xpath(pre_title + '/div/div[2]/input').send_keys(self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath(pre_title + '/div/div[3]/button[2]').click()

        time.sleep(10)
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath(
            "/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a"))

        self.driver.find_element_by_xpath(
            '/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a').click()

    def test01(self):
        self.logger.info("start test01")
        for i in range(10):
            self.logger.info("loop:" + str(i))

            self.driver.get(self.httpRequest)

            is_import_wallet = False

            try:
                WebDriverWait(self.driver, 10).until(lambda x: x.find_element_by_xpath(
                    "/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button"))
            except Exception as e:
                self.logger.info('Need import wallet:')
                self.importWallet()
                is_import_wallet = True

            self.doPay(is_import_wallet)

            check_title = False
            for j in range(20):
                title = self.driver.title
                if title == "Home":
                    check_title = True
                    break
                time.sleep(1)
            self.assertTrue(check_title, "Title Error")
            check_url = self.driver.current_url
            self.assertEqual(check_url, self.config['Parameter']['return_url'])

    # def test02(self):
    #     print("test02")
    #
    # def test03(self):
    #     print("test03")

if __name__ == "__main__":
    unittest.main()
