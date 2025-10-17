export interface Usuario {
  id: number
  username: string
  nombre_completo: string
  email: string
  rol_id: number
  rol_nombre: string
  permisos: string[]
}

export interface LoginResponse {
  mensaje: string
  token: string
  usuario: Usuario
}

export interface UsuarioListado {
  id: number
  username: string
  nombre_completo: string
  email: string
  rol_id: number
  rol_nombre: string
  activo: boolean
  created_at: string
}
