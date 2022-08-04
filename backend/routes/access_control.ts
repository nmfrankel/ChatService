import { Router } from 'express'
import { login } from '../controllers/access_controlController'

const router = Router()

router.use("/login", (req, res) => login(req, res))

router.post('/logout', (req, res) => 
	res.cookie('user', '', { maxAge: 1000 }).redirect('/login'))

module.exports = router