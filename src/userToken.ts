import storage from '$lib/utils/store'

export const userToken = storage<UserToken>('userToken', {
	sub: '',
	given_name: 'Unknown',
	family_name: 'user',
	handle: '',
	role: 'UNAUTHENTICATED'
})

export const partnerToken = storage<UserToken>('partnerToken', {
	sub: '',
	given_name: 'Unknown',
	family_name: 'conversation',
	handle: 'missing',
	role: 'N/A'
})
