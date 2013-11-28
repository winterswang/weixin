# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: http://doc.scrapy.org/en/latest/topics/item-pipeline.html
from datetime import datetime
from hashlib import md5
from scrapy import log
from scrapy.exceptions import DropItem
from twisted.enterprise import adbapi

class MytestPipeline(object):
    def process_item(self, item, spider):
        return item

class SQLStorePipeline(object):
 
    def __init__(self, dbpool):
        self.dbpool = dbpool

    @classmethod
    def from_settings(cls, settings):
        dbargs = dict(
            host=settings['MYSQL_HOST'],
            db=settings['MYSQL_DBNAME'],
            user=settings['MYSQL_USER'],
            passwd=settings['MYSQL_PASSWD'],
            charset='utf8',
            use_unicode=True,
        )
        dbpool = adbapi.ConnectionPool('MySQLdb', **dbargs)
        return cls(dbpool)
 
    def process_item(self, item, spider):
        # run db query in thread pool
        query = self.dbpool.runInteraction(self._conditional_insert, item)
        query.addErrback(self.handle_error)
        # if item['tel'] ==0:
        #     raise DropItem("Missing tel in %s" % item)
        return item
 
    def _conditional_insert(self, tx, item):
        # create record if doesn't exist. 
        # all this block run on it's own thread
        now = datetime.utcnow().replace(microsecond=0).isoformat(' ')
        tx.execute("select * from agent_sina where tel = %s", (item['tel'],))
        result = tx.fetchone()
        if result:
            log.msg("Item already stored in db: %s" % item, level=log.DEBUG)
        else:
            tx.execute(
                "insert into agent_sina (name, tel,company,city,createtime,store_url,store_name,head_url,circle) values (%s,%s,%s,%s,%s,%s,%s,%s,%s)" , (item['name'],item['tel'],item['company'],item['city'],now,item['store_url'],item['store_name'],item['head_url'],item['circle'])
            )
            log.msg("Item stored in db: %s" % item, level=log.DEBUG)
 
    def handle_error(self, e):
        log.err(e)
