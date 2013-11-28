# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

from scrapy.item import Item, Field

class Website(Item):

    name = Field()
    description = Field()
    url = Field()

class DoubanItem(Item):
    groupName = Field()
    groupURL  = Field()
    totalNumber = Field()
    relativeGroups = Field()
    activeUsers = Field()

class SoufunItem(Item):
    name = Field()
    tel  = Field()
    company = Field()
    city = Field()
    circle = Field()
    store_url = Field()
    store_name = Field()
    head_url = Field()

	
