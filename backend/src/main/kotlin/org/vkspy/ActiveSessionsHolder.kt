package org.vkspy

import java.util.*

class ActiveSessionsHolder(val db: VkSpyDb)
{
    private val statuses = HashMap<Int, Session>() ;
    fun addStatuses(response: Collection<ResponseEntry>) {
        for (entry in response) {
            val uid = entry.uid
//            statuses.get()
        }
    }
}
