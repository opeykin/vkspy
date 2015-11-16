package org.vkspy

import org.slf4j.LoggerFactory

fun main(args: Array<String>) {
    val logger = LoggerFactory.getLogger("main");

    try {
        val accessor = VkAccessor()
        val parser = VkParser()
        val idsSource = IdsSource()
        val dbWriter = DBWriter()

        kotlin.concurrent.timer("MyTimer", false, 0, 5000, {
            try {
                val ids = idsSource.get()
                val json = accessor.checkOnline(ids)
                val response = parser.parseOnline(json)
                dbWriter.write(response)
                logger.info("Got ${response.response.size} statuses")
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
