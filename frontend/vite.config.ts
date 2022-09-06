import { sveltekit } from '@sveltejs/kit/vite'
import type { UserConfig } from 'vite'

// import { loadEnv } from 'vite'

// Load env file based on `mode` in the current working directory.
// Set the third parameter to '' to load all env regardless of the `VITE_` prefix.
// const env = loadEnv(mode, process.cwd(), '')

const config: UserConfig = {
	plugins: [sveltekit()],
	define: {
		'import.meta.env.VERCEL_ANALYTICS_ID': JSON.stringify(process.env.VERCEL_ANALYTICS_ID),
		'import.meta.env.DATABASE_URL': process.env.DATABASE_URL
	}
}

export default config
