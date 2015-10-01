package org.vkspy

fun main(args: Array<String>) {
    val accessor = VkAccessor()
    val parser = VkParser()
    val ids = arrayListOf("opeykin", "alexey.kudinkin")
    val response = accessor.checkOnline(ids)
    val onlineList = parser.parseOnline(response)
    println(onlineList)
}
