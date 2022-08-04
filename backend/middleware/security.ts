import { Request, Response, NextFunction } from 'express'

module.exports = (req: Request, res: Response, next: NextFunction) => {
	//  logging out && allow
	if (req.originalUrl.startsWith("/access_control")) next()

	// decrypt cookie and check time and user
	const cookie: String | undefined = req.cookies.user
	if(!cookie || cookie !== 'loggedIn: true'){
		console.log(`No Cookie || Denied @ ${req.ip}`)
		res.redirect("/login")
	}

	console.log(`Access granted @ ${req.ip} - cookie refreshed`)
	res.cookie(
		'user',
		'loggedIn: true',
		{ maxAge: 600000, httpOnly: true }
	)
}