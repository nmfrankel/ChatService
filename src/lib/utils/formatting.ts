export const readableTime = (timestamp: string, detailed = false): string => {
	const inputTime = new Date(timestamp),
		inputTimestamp = new Date(timestamp).getTime() / 1000,
		currentTime = new Date(),
		currentTimestamp = new Date().getTime() / 1000,
		hr = (inputTime.getHours() % 12 || 12).toString(),
		min = inputTime.getMinutes().toString().padStart(2, '0'),
		meridian = inputTime.getHours() < 12 ? 'AM' : 'PM'
	let displayTime: string

	// Convert to readable format
	if (currentTimestamp - inputTimestamp < 60) {
		return 'Now' // 'Under a min'
	} else if (currentTimestamp - inputTimestamp < 3600 * 11.9) {
		return `${hr}:${min} ${meridian}`
	} else if (
		currentTimestamp - inputTimestamp < 3600 * 48 &&
		currentTime.getDay() + 6 === inputTime.getDay() + 7
	) {
		displayTime = 'Yesterday'
	} else if (currentTimestamp - inputTimestamp < 3600 * 24 * 7) {
		displayTime = inputTime.toLocaleString('en-us', { weekday: 'long' })
	} else if (currentTimestamp - inputTimestamp < 3600 * 24 * 364) {
		displayTime = `${inputTime.toLocaleString('default', {
			month: 'short'
		})} ${inputTime.getDate()}`
	} else {
		displayTime = `${inputTime.getMonth() + 1}/${inputTime.getDate()}/${
			inputTime.getFullYear() - 2000
		}`
	}

	if (detailed) displayTime += `, ${hr}:${min} ${meridian}`

	return displayTime
}

export const colorHash = (seed: string): string => {
	let colorCode = 0
	for (const letter of seed) {
		if (letter) colorCode += letter.charCodeAt(0) * 2
	}
	return 'avatarColor_' + (colorCode % 11).toString()
}
