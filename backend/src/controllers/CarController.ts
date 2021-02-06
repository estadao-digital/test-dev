
import { error } from 'console'
import { Request, Response } from 'express'

import CarSchema from '../models/CarModel'


export default class CarController {



  public async index(req: Request, res: Response) {
    const car = await CarSchema.find()
    return res.json(car);
  }

  public async show(req: Request, res: Response) {
    const car = await CarSchema.findById(req.params._id);
    return res.json(car);
  }


  public async create(req: Request, res: Response) {
    const { marca, modelo, ano } = req.body
    const car = await CarSchema.create({
      marca,
      modelo,
      ano
    })
    return res.json(car)
  }

  public async update(req: Request, res: Response) {
    try {
      const car = await CarSchema.findByIdAndUpdate(req.params._id, req.body, {
        new: true
      });
      return res.json([{
        "message": "Carro editado com sucesso"
      }, car]);
    } catch (error) {
      return res.json({ error: 'houve algum errro' })
    }
  }

  public async destroy(req: Request, res: Response) {
    try {
      await CarSchema.findByIdAndDelete(req.params._id);
      return res.json({
        "message": "Carro Deletado com sucesso"
      });
    } catch (error) {
      return res.json({ error: 'houve algum errro' })
    }
  }

}
