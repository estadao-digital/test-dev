import { Component, OnInit } from '@angular/core';

import { Carro } from './carro';
import { CarroService } from './carro.service';

import { Marca } from './marca';
import { MarcaService } from './marca.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit  {
  carros: Carro[];
  carroUpdate: Carro;
  carroDeletar: Carro;
  carroCreating: Boolean = false;
  marcas: Marca[];

  constructor(private carroService: CarroService,
              private marcaService: MarcaService) { }

  ngOnInit() {
    this.marcaService.getMarcas().subscribe(marcas => this.marcas = marcas );;
    this.getCarros();
  }

  showCreate():void {
    this.carroCreating = true;
  }

  cancelCreate():void {
    this.carroCreating = false;
  }

  create(marca: string, modelo:String, ano:String): void {
    marca = marca.trim();
    modelo = modelo.trim();
    ano = ano.trim();

    if (!marca || !modelo || !ano) { return; }
    
    this.carroService.createCarro({ marca, modelo, ano } as Carro)
      .subscribe(carro => {
        this.carros.push(carro);
      });

    this.cancelCreate();
  }

  getCarros(): void {
    this.carroService.getCarros()
    .subscribe(carros => this.carros = carros );
  }

  update_show(carro:Carro):void {
    this.carroUpdate = carro;
  }

  update(): void {
    this.carroService.updateCarro(this.carroUpdate).subscribe();
    this.cancel_update();    
  }

  cancel_update(): void {
    this.carroUpdate = null;
  }

  preDelete(carro: Carro): void {
    this.carroDeletar = carro;
  }

  delete(carro: Carro): void {
    this.carros = this.carros.filter(c => c !== carro);
    this.carroService.deleteCarro(carro).subscribe();
  }
}
