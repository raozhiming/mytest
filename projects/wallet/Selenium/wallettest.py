# coding:utf-8

import logging
import os
import time
import unittest
import yaml

from selenium import webdriver
from selenium.webdriver.support.wait import WebDriverWait


class Test(unittest.TestCase):
    def setUp(self):
        print("setUp")

        self.initLogger()
        self.loadConfig()
        self.driver = webdriver.Firefox()
        # self.driver.set_window_size(560, 960)
        self.driver.get(self.config['ElaPayUrl'])

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
        self.email_len = len(self.config['Email'])
        f.close()

    def checkOutOrder(self, index=1):
        self.logger.info("----checkOutOrder----")
        # email_index = index / self.email_len
        email_index = 0

        time_str = time.strftime('%Y-%m-%d %H:%M:%S', time.localtime(time.time()))
        order_name = str(index) + " " + self.config['ORDER']['Name'] + " " + time_str
        self.driver.find_element_by_id('orderName').send_keys(order_name)
        self.driver.find_element_by_id('orderDesc').send_keys(self.config['ORDER']['Desc'])
        self.driver.find_element_by_id('businessName').send_keys(self.config['ORDER']['BusinessName'])
        # combobox
        self.driver.find_element_by_id('price').send_keys(self.config['ORDER']['Price'])
        self.driver.find_element_by_id('discountPecent').send_keys(self.config['ORDER']['DiscountPercent'])
        self.driver.find_element_by_id('walletAddress').send_keys(self.config['Wallet']['Address'])
        self.driver.find_element_by_id('callbackUrl').send_keys(self.config['Url']['Callback'])
        self.driver.find_element_by_id('returnUrl').send_keys(self.config['Url']['Return'])
        self.driver.find_element_by_id('email').send_keys(self.config['Email'][email_index])
        self.logger.info("Email:" + self.config['Email'][email_index])
        self.driver.find_element_by_class_name('btn-checkout').click()

    def payWithELA(self):
        self.logger.info("----payWithELA----")
        time.sleep(2)
        WebDriverWait(self.driver, 20, 0.5).until(lambda x: x.find_element_by_class_name('btn-checkout'))
        time.sleep(2)
        self.driver.find_element_by_class_name('btn-checkout').click()

    def importWallet(self):
        self.logger.info("----importWallet----")
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_id("restore"))
        self.driver.find_element_by_id('restore').click()

        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_class_name("ng-valid"))
        self.driver.find_element_by_class_name('ng-valid').send_keys(self.config['Wallet']['Mnemonic'])
        self.driver.find_element_by_name('requestPassword').send_keys(self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/div/div[5]/input').send_keys(self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/button').click()

    def addMemo(self, is_import_wallet=False):
        memo_xpath_tag = "/span[1]/span"
        input_xpath_tag = "/html/body/div[5]"
        if is_import_wallet:
            input_xpath_tag = "/html/body/div[6]"

        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/ion-content/div/div/div[2]/a[2]'+memo_xpath_tag).click()
        WebDriverWait(self.driver, 10, 0.5).until(lambda x: x.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input'))
        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input').send_keys("add memo")
        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[3]/button[2]').click()

    def doPay(self, is_import_wallet=False):
        self.logger.info("----doPay----")
        time.sleep(15)

        self.addMemo(is_import_wallet)
        time.sleep(1)
        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button').click()

        pre_title = "/html/body/div[5]"
        if is_import_wallet:
            pre_title = "/html/body/div[6]"
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath(pre_title + "/div/div[2]/input"))
        self.driver.find_element_by_xpath(pre_title + '/div/div[2]/input').send_keys(self.config['Wallet']['Password'])
        self.driver.find_element_by_xpath(pre_title + '/div/div[3]/button[2]').click()

        time.sleep(10)
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath("/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a"))

        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a').click()

    def test01(self):
        self.logger.info("start test01")
        for i in range(10):
            self.logger.info("loop:" + str(i))
            WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_id('orderName'))

            self.checkOutOrder(i)
            # time.sleep(2)
            self.payWithELA()
            time.sleep(5)

            is_import_wallet = False

            try:
                WebDriverWait(self.driver, 10).until(lambda x: x.find_element_by_xpath("/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button"))
            except Exception as e:
                self.logger.info('Need import wallet:')
                self.importWallet()
                is_import_wallet = True

            self.doPay(is_import_wallet)

    # def test02(self):
    #     print("test02")
    #     print(self.driver.title)


if __name__ == "__main__":
    unittest.main()
