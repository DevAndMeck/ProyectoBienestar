export interface Registro {
  id?: number
  titulo: string
  descripcion: string
  usuario_id?: number
  creador?: string
  created_at?: string
  updated_at?: string
}

export interface RegistrosResponse {
  registros: Registro[]
}
