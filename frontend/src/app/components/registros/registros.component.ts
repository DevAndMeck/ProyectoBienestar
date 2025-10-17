import { Component, type OnInit } from "@angular/core"
import { CommonModule } from "@angular/common"
import { FormsModule } from "@angular/forms"
import { RouterModule } from "@angular/router"
import { AuthService } from "../../services/auth.service"
import { RegistroService } from "../../services/registro.service"
import { Registro } from "../../models/registro.model"
import { HasPermissionDirective } from "../../directives/has-permission.directive"

@Component({
  selector: "app-registros",
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule, HasPermissionDirective],
  templateUrl: "./registros.component.html",
  styleUrls: ["./registros.component.css"],
})
export class RegistrosComponent implements OnInit {
  registros: Registro[] = []
  mostrarFormulario = false
  modoEdicion = false
  registroActual: Registro = { titulo: "", descripcion: "" }
  mensaje = ""
  tipoMensaje: "success" | "danger" | "" = ""

  constructor(
    public authService: AuthService,
    private registroService: RegistroService,
  ) {}

  ngOnInit(): void {
    this.cargarRegistros()
  }

  cargarRegistros(): void {
    this.registroService.listar().subscribe({
      next: (response) => {
        this.registros = response.registros
      },
      error: (err) => {
        this.mostrarMensaje("Error al cargar registros", "danger")
      },
    })
  }

  abrirFormularioCrear(): void {
    this.modoEdicion = false
    this.registroActual = { titulo: "", descripcion: "" }
    this.mostrarFormulario = true
    this.mensaje = ""
  }

  abrirFormularioEditar(registro: Registro): void {
    this.modoEdicion = true
    this.registroActual = { ...registro }
    this.mostrarFormulario = true
    this.mensaje = ""
  }

  cancelar(): void {
    this.mostrarFormulario = false
    this.registroActual = { titulo: "", descripcion: "" }
    this.mensaje = ""
  }

  guardar(): void {
    if (!this.registroActual.titulo || !this.registroActual.descripcion) {
      this.mostrarMensaje("Por favor complete todos los campos", "danger")
      return
    }

    if (this.modoEdicion) {
      this.registroService.actualizar(this.registroActual).subscribe({
        next: () => {
          this.mostrarMensaje("Registro actualizado exitosamente", "success")
          this.cargarRegistros()
          this.cancelar()
        },
        error: (err) => {
          this.mostrarMensaje(err.error?.mensaje || "Error al actualizar registro", "danger")
        },
      })
    } else {
      this.registroService.crear(this.registroActual).subscribe({
        next: () => {
          this.mostrarMensaje("Registro creado exitosamente", "success")
          this.cargarRegistros()
          this.cancelar()
        },
        error: (err) => {
          this.mostrarMensaje(err.error?.mensaje || "Error al crear registro", "danger")
        },
      })
    }
  }

  eliminar(id: number): void {
    if (confirm("¿Está seguro de eliminar este registro?")) {
      this.registroService.eliminar(id).subscribe({
        next: () => {
          this.mostrarMensaje("Registro eliminado exitosamente", "success")
          this.cargarRegistros()
        },
        error: (err) => {
          this.mostrarMensaje(err.error?.mensaje || "Error al eliminar registro", "danger")
        },
      })
    }
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
