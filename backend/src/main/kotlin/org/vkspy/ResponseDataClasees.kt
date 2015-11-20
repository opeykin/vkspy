package org.vkspy

data class OnlineStatus(val uid: Int,
                        val first_name: String,
                        val last_name: String,
                        val hidden: Int,
                        val online: Int,
                        val online_mobile: Int = 0,
                        val online_app: Int = 0)

data class OnlineResponse(val response: Collection<OnlineStatus>) {
}
