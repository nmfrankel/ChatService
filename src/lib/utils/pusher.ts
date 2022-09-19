import Pusher from 'pusher'

declare global {
	var pusher: Pusher | undefined
}

export const pusher =
	global.pusher ||
	new Pusher({
		appId: import.meta.env.VITE_PUSHER_APP_ID,
		key: import.meta.env.VITE_PUSHER_KEY,
		secret: import.meta.env.VITE_PUSHER_SECRET,
		cluster: 'eu',
		useTLS: true
	})

if (process.env.NODE_ENV !== 'production') global.pusher = pusher
