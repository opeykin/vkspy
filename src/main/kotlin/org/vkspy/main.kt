package org.vkspy

fun main(args: Array<String>) {
    val accessor = VkAccessor()
    val parser = VkParser()
    val idsSource = IdsSource()
    val statusLogger = StatusLogger()

    val ids = idsSource.get()
    val response = accessor.checkOnline(ids)
    val statuses = parser.parseOnline(response)
    statusLogger.log(statuses)
}
