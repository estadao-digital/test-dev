
import { error } from 'console'
import { Request, Response } from 'express'

import MarcaSchema from '../models/MarcaModel'


export default class MarcaController {



  public async index(req: Request, res: Response) {
    const marca = await MarcaSchema.find()
    return res.json(marca);
  }

  public async create(req: Request, res: Response) {
    const { marca } = req.body
    const brand = await MarcaSchema.create({
      marca,

    })
    return res.json(brand)
  }



}