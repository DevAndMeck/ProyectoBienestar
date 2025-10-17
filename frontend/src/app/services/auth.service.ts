import { Injectable } from "@angular/core"
import { HttpClient } from "@angular/common/http"
import { BehaviorSubject, type Observable, tap } from "rxjs"
import { Router } from "@angular/router"
import { Usuario, LoginResponse } from "../models/usuario.model"

@Injectable({
  providedIn: "root",
})
export class AuthService {
  private apiUrl = "http://localhost:8000/api"
  private currentUserSubject = new BehaviorSubject<Usuario | null>(null)
  public currentUser$ = this.currentUserSubject.asObservable()

  constructor(
    private http: HttpClient,
    private router: Router,
  ) {
    this.cargarUsuarioDesdeStorage()
  }

  login(username: string, password: string): Observable<LoginResponse> {
    return this.http
      .post<LoginResponse>(`${this.apiUrl}/auth/login.php`, {
        username,
        password,
      })
      .pipe(
        tap((response) => {
          if (response.token && response.usuario) {
            localStorage.setItem("token", response.token)
            localStorage.setItem("usuario", JSON.stringify(response.usuario))
            this.currentUserSubject.next(response.usuario)
          }
        }),
      )
  }

  logout(): void {
    localStorage.removeItem("token")
    localStorage.removeItem("usuario")
    this.currentUserSubject.next(null)
    this.router.navigate(["/login"])
  }

  getToken(): string | null {
    return localStorage.getItem("token")
  }

  getCurrentUser(): Usuario | null {
    return this.currentUserSubject.value
  }

  isAuthenticated(): boolean {
    return !!this.getToken()
  }

  tienePermiso(permiso: string): boolean {
    const usuario = this.getCurrentUser()
    return usuario ? usuario.permisos.includes(permiso) : false
  }

  esAdministrador(): boolean {
    const usuario = this.getCurrentUser()
    return usuario ? usuario.rol_nombre === "Administrador" : false
  }

  private cargarUsuarioDesdeStorage(): void {
    const usuarioStr = localStorage.getItem("usuario")
    if (usuarioStr) {
      try {
        const usuario = JSON.parse(usuarioStr)
        this.currentUserSubject.next(usuario)
      } catch (e) {
        console.error("Error al cargar usuario desde storage", e)
      }
    }
  }
}
