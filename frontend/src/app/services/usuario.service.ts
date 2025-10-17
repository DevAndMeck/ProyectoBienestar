import { Injectable } from "@angular/core"
import { HttpClient } from "@angular/common/http"
import { Observable } from "rxjs"
import { UsuarioListado } from "../models/usuario.model"

@Injectable({
  providedIn: "root",
})
export class UsuarioService {
  private apiUrl = "http://localhost:8000/api/usuarios"

  constructor(private http: HttpClient) {}

  listar(): Observable<{ usuarios: UsuarioListado[] }> {
    return this.http.get<{ usuarios: UsuarioListado[] }>(`${this.apiUrl}/listar.php`)
  }
}
