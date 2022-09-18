import { json } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import Pusher from 'pusher'

const pusher = new Pusher({
	appId: import.meta.env.VITE_PUSHER_APP_ID,
	key: import.meta.env.VITE_PUSHER_KEY,
	secret: import.meta.env.VITE_PUSHER_SECRET,
	cluster: 'eu',
	useTLS: true
})

export const POST: RequestHandler = async ({ request }) => {
	const body = await request.text()
	const socketId = body.match(/socket_id=([^&]*)/)?.[1] ?? ''
	const channel = body.match(/channel_name=([^&]*)/)?.[1] ?? ''

	const authResponse = pusher.authorizeChannel(socketId, channel)
	return json(authResponse)
}

// POST:	Authenticate user
// export const POST: RequestHandler = async ({ request }) => {
// const body = await request.text()
// const socketId = body.match(/socket_id=([^&]*)/)?.[1]

// const user = {
// 	id: "0000-0000",
// 	user_info: {
// 		name: "Nosson M Frankel",
// 	}
// }

// const authResponse = pusher.authenticateUser(socketId, user)
// return json(authResponse)
// }
