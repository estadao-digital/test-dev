import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule }    from '@angular/common/http';
import { FormsModule }    from '@angular/forms';


import { AppComponent } from './app.component';
import { CarroService } from './carro.service';
import { MarcaService } from './marca.service';


@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [CarroService, MarcaService],
  bootstrap: [AppComponent]
})
export class AppModule { }
