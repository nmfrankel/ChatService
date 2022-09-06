import { sveltekit } from '@sveltejs/kit/vite'
import type { UserConfig } from 'vite'

// console.log(JSON.stringify(process.env.DATABASE_URL))

const config: UserConfig = {
	plugins: [sveltekit()],
	define: {
		'import.meta.env.VERCEL_ANALYTICS_ID': JSON.stringify(process.env.VERCEL_ANALYTICS_ID),
		'import.meta.env.DATABASE_URL': JSON.stringify(process.env.DATABASE_URL)
	}
}

export default config
