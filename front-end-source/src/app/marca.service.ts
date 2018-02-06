import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import { Marca } from './marca';


@Injectable()
export class MarcaService {

  //private marcasUrl = 'http://localhost:8000/marcas';  // URL to web api
  private marcasUrl = './api/marcas';  // URL to web api

  constructor( private http: HttpClient ) { }

  /** GET marcas from the server */
  getMarcas (): Observable<Marca[]> {
    return this.http.get<Marca[]>(this.marcasUrl)
          .pipe(
                tap(marcas => this.log(`fetched marcas`)),
                catchError(this.handleError('getMarcas', []))
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

  /** Log a MarcaService message */
  private log(message: string) {
    console.log("MarcaService:" + message);
  }
}
