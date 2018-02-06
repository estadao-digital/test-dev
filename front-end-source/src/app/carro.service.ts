import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import { Carro } from './carro';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class CarroService {

  //private carrosUrl = 'http://localhost:8000/carros';  // URL to web api
  private carrosUrl = './api/carros';  // URL to web api

  constructor( private http: HttpClient ) { }

  /** GET carros from the server */
  getCarros (): Observable<Carro[]> {
    return this.http.get<Carro[]>(this.carrosUrl)
          .pipe(
                tap(carros => this.log(`fetched carros`)),
                catchError(this.handleError('getCarros', []))
              );
  }

  /** GET carro by id. */
  getCarro(id: number): Observable<Carro> {
    const url = `${this.carrosUrl}/${id}`;
    return this.http.get<Carro>(url).pipe(
      tap(_ => this.log(`fetched carro id=${id}`)),
      catchError(this.handleError<Carro>(`getCarro id=${id}`))
    );
  }

  //////// Save methods //////////

  /** POST: create a new carro to the server */
  createCarro (carro: Carro): Observable<Carro> {
    return this.http.post<Carro>(this.carrosUrl, carro, httpOptions).pipe(
      tap((carro: Carro) => this.log(`added carro w/ id=${carro.id}`)),
      catchError(this.handleError<Carro>('erro createCarro'))
    );
  }

  /** DELETE: delete the carro from the server */
  deleteCarro (carro: Carro): Observable<Carro> {
    const id = carro.id;
    const url = `${this.carrosUrl}/${id}`;

    return this.http.delete<Carro>(url).pipe(
      tap(_ => this.log(`deleted carro id=${id}`)),
      catchError(this.handleError<Carro>('deleteCarro'))
    );
  }

  /** PUT: update the carro on the server */
  updateCarro (carro: Carro): Observable<any> {
    const id = carro.id;
    const url = `${this.carrosUrl}/${id}`;
    return this.http.put(url, carro, httpOptions).pipe(
      tap(_ => this.log(`updated carro id=${carro.id}`)),
      catchError(this.handleError<any>('updateCarro'))
    );
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  /** Log a CarroService message  */
  private log(message: string) {
    console.log("CarroService:" + message);
  }
}
