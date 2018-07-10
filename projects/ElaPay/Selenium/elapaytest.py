# coding:utf-8

import time
import unittest

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait

class Test(unittest.TestCase):
    def setUp(self):
        print("setUp")
        profile = webdriver.FirefoxProfile()
        profile.set_preference("browser.startup.homepage", "about:blank")
        profile.set_preference("startup.homepage_welcome_url", "about:blank")
        profile.set_preference("startup.homepage_welcome_url.additional", "about:blank")

        profile.assume_untrusted_cert_issuer = True
        profile.accept_untrusted_certs = True

        profile.set_preference('permissions.default.image', 2)  # 某些firefox只需要这个
        profile.set_preference('browser.migration.version', 9001)  # 部分需要加上这个

        self.driver = webdriver.Firefox(firefox_profile=profile)
        # self.driver.set_window_size(560, 960)
        self.driver.get("https://elapay-test.elastos.org/")

    def tearDown(self):
        print("tearDown")
        self.driver.quit()

    def checkOutOrder(self, index=1):
        print("----checkOutOrder----\r\n")
        self.driver.find_element_by_id('orderName').send_keys(str(index) + " orderName: Tmall apple mac")
        self.driver.find_element_by_id('orderDesc').send_keys("orderDesc: buy mac from apple")
        self.driver.find_element_by_id('businessName').send_keys("businessName: apple.inc")
        # combobox
        self.driver.find_element_by_id('price').send_keys("1")
        self.driver.find_element_by_id('discountPecent').send_keys("1")
        self.driver.find_element_by_id('walletAddress').send_keys("EUWTKNYSPbfVgZ4jWMZumaRSzkFsbH9CFv")
        self.driver.find_element_by_id('callbackUrl').send_keys("https://fun-test.elastos.org/api/v1/userReg")
        self.driver.find_element_by_id('returnUrl').send_keys("https://elapay-test.elastos.org/")
        self.driver.find_element_by_id('email').send_keys("raozhiming79@163.com")

        # time.sleep(1)
        self.driver.find_element_by_class_name('btn-checkout').click()

    def payWithELA(self):
        print("----payWithELA----\r\n")
        time.sleep(2)
        WebDriverWait(self.driver, 20, 0.5).until(lambda x: x.find_element_by_class_name('btn-checkout'))
        time.sleep(2)
        self.driver.find_element_by_class_name('btn-checkout').click()

    def importWallet(self):
        print("----importWallet----\r\n")
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_id("restore"))
        self.driver.find_element_by_id('restore').click()

        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_class_name("ng-valid"))
        self.driver.find_element_by_class_name('ng-valid').send_keys("饱 始 地 袖 造 华 持 糖 变 枪 加 膨")

        self.driver.find_element_by_name('requestPassword').send_keys("elastos2018")
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/div/div[5]/input').send_keys("elastos2018")
        self.driver.find_element_by_xpath('//*[@id="import"]/ion-content/div/div[2]/form/button').click()

    def addMemo(self, is_importWallet=False):
        memo_xpath_tag = "/span[1]/span"
        input_xpath_tag = "/html/body/div[5]"
        if is_importWallet:
            memo_xpath_tag = "/span[1]/span"
            input_xpath_tag = "/html/body/div[6]"

        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/ion-content/div/div/div[2]/a[2]'+memo_xpath_tag).click()
        WebDriverWait(self.driver, 10, 0.5).until(lambda x: x.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input'))
        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[2]/input').send_keys("add note")

        self.driver.find_element_by_xpath(input_xpath_tag + '/div/div[3]/button[2]').click()

    def doPay(self, is_importWallet=False):
        print("----doPay----\r\n")
        time.sleep(15)

        self.addMemo(is_importWallet)
        time.sleep(1)
        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button').click()

        pre_title = "/html/body/div[5]"
        if is_importWallet:
            pre_title = "/html/body/div[6]"
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath(pre_title + "/div/div[2]/input"))
        self.driver.find_element_by_xpath(pre_title + '/div/div[2]/input').send_keys("elastos2018")
        self.driver.find_element_by_xpath(pre_title + '/div/div[3]/button[2]').click()

        time.sleep(10)
        WebDriverWait(self.driver, 100).until(lambda x: x.find_element_by_xpath("/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a"))

        self.driver.find_element_by_xpath('/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/slide-to-accept-success/div[3]/a').click()

    def test01(self):
        print("test01\r\n")
        for i in range(5):
            print("loop:" + str(i))
            WebDriverWait(self.driver, 20).until(lambda x: x.find_element_by_id('orderName'))

            self.checkOutOrder(i)
            # time.sleep(2)
            self.payWithELA()
            time.sleep(5)

            is_importWallet = False

            try:
                WebDriverWait(self.driver, 10).until(lambda x: x.find_element_by_xpath("/html/body/ion-nav-view/ion-tabs/ion-nav-view[2]/ion-view/click-to-accept/button"))
            except Exception as e:
                print('Need import wallet:')
                self.importWallet()
                is_importWallet = True

            self.doPay(is_importWallet)

    # def test02(self):
    #     print("test02")
    #     print(self.driver.title)

if __name__ == "__main__":
    unittest.main()