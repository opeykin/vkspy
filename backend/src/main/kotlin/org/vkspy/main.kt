package org.vkspy

import org.slf4j.LoggerFactory

fun main(args: Array<String>) {
    val logger = LoggerFactory.getLogger("main");

    try {
        val accessor = VkAccessor()
        val parser = VkParser()
        val db = VkSpyDb()

        kotlin.concurrent.timer("MyTimer", false, 0, 5000, {
            try {
                val ids = db.getUserIds()
                val json = accessor.checkOnline(ids)
                val statuses = parser.parseOnline(json)
                db.writeStatuses(statuses)
                logger.info("Got ${statuses.size} statuses")
            } catch (ex: Exception) {
                logger.error("Timer", ex)
                throw ex
            }
        });


    } catch (ex: Exception) {
        logger.error("Initialization", ex)
        throw ex
    }
}
