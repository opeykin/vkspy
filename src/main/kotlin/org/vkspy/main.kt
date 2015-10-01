package org.vkspy

fun main(args: Array<String>) {
    val accessor = VkAccessor()
    val parser = VkParser()
    val idsSource = IdsSource()

    val ids = idsSource.get()
    val response = accessor.checkOnline(ids)
    val onlineList = parser.parseOnline(response)
    println(onlineList)
}
