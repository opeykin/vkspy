package org.vkspy

fun main(args: Array<String>) {
    val accessor = VkAccessor()
    val parser = VkParser()
    val idsSource = IdsSource()
    val statusLogger = StatusLogger()

    kotlin.concurrent.timer("MyTimer", false, 0, 5000, {
        val ids = idsSource.get()
        val json = accessor.checkOnline(ids)
        val response = parser.parseOnline(json)
        statusLogger.log(response)
    });
}
