import Router from 'express'
import CarController from '../controllers/CarController';
import MarcaController from '../controllers/MarcaController';


const route = Router();

const carController = new CarController
const marcaController = new MarcaController


route.get('/carros/', carController.index)

route.get('/carros/:_id', carController.show)

route.post('/carros', carController.create)

route.put('/carros/:_id', carController.update)

route.delete('/carros/:_id', carController.destroy)


//marca

route.post('/marcas', marcaController.create)

route.get('/marcas', marcaController.index)

export default route