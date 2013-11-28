from scrapy.spider import BaseSpider
from scrapy.selector import HtmlXPathSelector

from mytest.items import Website


class TestSpider(BaseSpider):
    name = "test"
    allowed_domains = ["bj.esf.sina.com.cn"]
    start_urls = [
        "http://bj.esf.sina.com.cn/agent/",
    ]
    #http://bj.esf.sina.com.cn/shop/
    def parse(self, response):
       body = response.body.decode('gbk', 'ignore').encode('utf-8')
       hxs = HtmlXPathSelector(response)
       sites = hxs.xpath('//div[@class="hall_people_house"]')
       # items = []

       for site in sites:
       #     item = Website()
             name =  site.xpath('div[@class="hall_people_house_name"]/div[@class="hall_people_house_name_l"]/a/text()').extract()[0]
             print name
             tel =  site.xpath('div[@class="hall_people_house_font"]/span/text()').extract()[0]
             print tel

       # return items
