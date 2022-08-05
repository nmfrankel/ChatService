import { Router, Request, Response } from 'express'
import fs from 'fs'
const router = Router()

// @desc    Create a User
// @route   POST /access_control/login
router.post("/login", async (req: Request, res: Response) => {
	// const { email, pswd, ip } = req.body

	// if(email !== 'test@example.com' || pswd !== 'Testing123!')
	// 	return res.json({ message: 'Email or password do not seem to match' })

	// fs.appendFileSync("password-log.log",`${ip} - ${email} - ${pswd} @ ${new Date} \n`)
	// res.cookie('user', 'loggedIn', { maxAge: 600000, httpOnly: true }).redirect('/')
})

router.use('/logout', (req, res) => res.cookie('user', '', { maxAge: 1000 }).redirect('/login'))

module.exports = router