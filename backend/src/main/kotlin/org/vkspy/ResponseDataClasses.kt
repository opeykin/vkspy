package org.vkspy

import java.time.LocalDateTime

data class ResponseEntry(val uid: Int,
                         val first_name: String,
                         val last_name: String,
                         val hidden: Int,
                         val online: Int,
                         val online_mobile: Int = 0,
                         val online_app: Int = 0,
                         val deactivated: String? = null)

data class OnlineResponse(val responseEntry: Collection<ResponseEntry>) {
}

data class Session(val uid: Int,
                   val online_mobile: Int,
                   val online_app: Int,
                   val start: LocalDateTime,
                   var duration: Int = 1)
