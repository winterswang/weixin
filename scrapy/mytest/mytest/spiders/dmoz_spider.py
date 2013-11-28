
from scrapy.spider import BaseSpider
from scrapy.selector import HtmlXPathSelector

from mytest.items import Website


class DmozSpider(BaseSpider):
    name = "dmoz"
    allowed_domains = ["dmoz.org"]
    start_urls = [
        "http://www.dmoz.org/Computers/Programming/Languages/Python/Books/",
        "http://www.dmoz.org/Computers/Programming/Languages/Python/Resources/",
    ]

    def parse(self, response):

       hxs = HtmlXPathSelector(response)
       sites = hxs.xpath('//ul[@class="directory-url"]/li')
       items = []

       for site in sites:
           item = Website()
           item['name'] = site.select('a/text()').extract()
           item['url'] = site.select('a/@href').extract()
           item['description'] = site.select('text()').re('-\s([^\n]*?)\\n')
           items.append(item)

       return items
