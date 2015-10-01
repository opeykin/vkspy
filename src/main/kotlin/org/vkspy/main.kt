package org.vkspy

fun main(args: Array<String>) {
    val accessor = VkAccessor()
    val ids = arrayListOf("opeykin", "alexey.kudinkin")
    val response = accessor.checkOnline(ids)
    println(response)
}
