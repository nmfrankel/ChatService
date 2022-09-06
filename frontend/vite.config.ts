import { sveltekit } from '@sveltejs/kit/vite'
import type { UserConfig } from 'vite'
import { loadEnv } from 'vite'

const config: UserConfig = {
	
	plugins: [sveltekit()],
	define: {
		'import.meta.env.VERCEL_ANALYTICS_ID': JSON.stringify(process.env.VERCEL_ANALYTICS_ID),
		'process.env': {...process.env, ...loadEnv('', process.cwd())}
	}
}

export default config
