import { Injectable } from "@angular/core"
import { HttpClient } from "@angular/common/http"
import { Observable } from "rxjs"
import { Registro, RegistrosResponse } from "../models/registro.model"

@Injectable({
  providedIn: "root",
})
export class RegistroService {
  private apiUrl = "http://localhost:8000/api/registros"

  constructor(private http: HttpClient) {}

  listar(): Observable<RegistrosResponse> {
    return this.http.get<RegistrosResponse>(`${this.apiUrl}/listar.php`)
  }

  crear(registro: Registro): Observable<any> {
    return this.http.post(`${this.apiUrl}/crear.php`, registro)
  }

  actualizar(registro: Registro): Observable<any> {
    return this.http.put(`${this.apiUrl}/actualizar.php`, registro)
  }

  eliminar(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/eliminar.php`, {
      body: { id },
    })
  }
}
