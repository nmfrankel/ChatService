import { json } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import Pusher from 'pusher'

// GET:    Test pusher implemention
export const GET: RequestHandler = () => {
	const pusher = new Pusher({
		appId: import.meta.env.VITE_PUSHER_APP_ID,
		key: import.meta.env.VITE_PUSHER_KEY,
		secret: import.meta.env.VITE_PUSHER_SECRET,
		cluster: 'eu',
		useTLS: true
	})

	pusher.trigger('private-chat-userId', 'message', {
		message: 'hello world'
	})

	return json({ sent: true })
}
