import Router from 'express'
import CarController from '../controllers/CarController';


const route = Router();

const carController = new CarController



route.get('/carros/', carController.index)

route.get('/carros/:_id', carController.show)

route.post('/carros', carController.create)

route.put('/carros/:_id', carController.update)

route.delete('/carros/:_id', carController.destroy)

export default route