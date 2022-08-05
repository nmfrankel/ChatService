import { Request, Response, NextFunction } from 'express'

module.exports = (req: Request, res: Response, next: NextFunction) => {
	//  logging out && allow
	if (req.originalUrl.startsWith('/access_control')) next()

	// decrypt cookie and check time and user
	const cookie: String = req.cookies?.user ?? ''

	if(cookie === 'loggedIn'){
		console.log(`Access granted @ ${req.ip} - cookie refreshed`)
		// res.cookie(
		// 	'user',
		// 	'loggedIn',
		// 	{ maxAge: 600000, httpOnly: true }
		// )
		// next()
	}else{
		console.log(`${ !cookie ? 'No cookie': 'Denied' } @ ${req.ip}`)
		// res.redirect("/login.html")
		// res.redirect("/access_control")
	}


	// override file temporarily
	// override file temporarily
	// override file temporarily
	next()
}