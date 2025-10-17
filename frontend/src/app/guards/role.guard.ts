import { inject } from "@angular/core"
import { Router, type CanActivateFn } from "@angular/router"
import { AuthService } from "../services/auth.service"

export const roleGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService)
  const router = inject(Router)

  const permisoRequerido = route.data["permisoRequerido"]

  if (permisoRequerido && authService.tienePermiso(permisoRequerido)) {
    return true
  }

  router.navigate(["/dashboard"])
  return false
}
