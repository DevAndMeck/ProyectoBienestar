import { Component, type OnInit } from "@angular/core"
import { CommonModule } from "@angular/common"
import { RouterModule } from "@angular/router"
import { AuthService } from "../../services/auth.service"
import { UsuarioService } from "../../services/usuario.service"
import { UsuarioListado } from "../../models/usuario.model"

@Component({
  selector: "app-usuarios",
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: "./usuarios.component.html",
  styleUrls: ["./usuarios.component.css"],
})
export class UsuariosComponent implements OnInit {
  usuarios: UsuarioListado[] = []
  mensaje = ""
  tipoMensaje: "success" | "danger" | "" = ""

  constructor(
    public authService: AuthService,
    private usuarioService: UsuarioService,
  ) {}

  ngOnInit(): void {
    this.cargarUsuarios()
  }

  cargarUsuarios(): void {
    this.usuarioService.listar().subscribe({
      next: (response) => {
        this.usuarios = response.usuarios
      },
      error: (err) => {
        this.mostrarMensaje("Error al cargar usuarios", "danger")
      },
    })
  }

  private mostrarMensaje(texto: string, tipo: "success" | "danger"): void {
    this.mensaje = texto
    this.tipoMensaje = tipo
    setTimeout(() => {
      this.mensaje = ""
      this.tipoMensaje = ""
    }, 5000)
  }
}
