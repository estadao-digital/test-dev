import { Component, OnInit } from '@angular/core';
import { CarService } from './services/carro.service';
import { BrandService } from './services/brand.service';
import { Car } from './models/carro';
import { Brand } from './models/brand';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {

  brand = {} as Brand;
  brands?: Brand[];

  car = {} as Car;
  cars?: Car[];

  constructor(private carService: CarService, private brandService: BrandService) {}

  ngOnInit() {
    this.getCars();
    this.getBrands();
  }

  // Verificação para salvar ou editar um carro
  saveCar(form: NgForm) {
    if (this.car.id !== undefined) {
      this.carService.updateCar(this.car).subscribe(() => {
        this.cleanForm(form);
      });
    } else {
      this.carService.saveCar(this.car).subscribe(() => {
        this.cleanForm(form);
      });
    }
  }

  // Listagem de Todos os Carros
  getCars() {
    this.carService.getCars().subscribe((cars: Car[]) => {
      this.cars = cars;
    });
  }

  // Listagem de Todas as Marcas
  getBrands() {
    this.brandService.getBrands().subscribe((brands: Brand[]) => {
      this.brands = brands;
    });
  }

  // Exclusão de Carro
  deleteCar(car: Car) {
    this.carService.deleteCar(car).subscribe(() => {
      this.getCars();
    });
  }

  // Copia o item para edição
  editCar(car: Car) {
    this.car = { ...car };
  }

  // limpa o formulario
  cleanForm(form: NgForm) {
    this.getCars();
    form.resetForm();
    this.car = {} as Car;
  }

}