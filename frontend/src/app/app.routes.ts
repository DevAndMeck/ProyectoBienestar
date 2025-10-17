import type { Routes } from "@angular/router"
import { authGuard } from "./guards/auth.guard"
import { roleGuard } from "./guards/role.guard"

export const routes: Routes = [
  {
    path: "login",
    loadComponent: () => import("./components/login/login.component").then((m) => m.LoginComponent),
  },
  {
    path: "dashboard",
    loadComponent: () => import("./components/dashboard/dashboard.component").then((m) => m.DashboardComponent),
    canActivate: [authGuard],
  },
  {
    path: "registros",
    loadComponent: () => import("./components/registros/registros.component").then((m) => m.RegistrosComponent),
    canActivate: [authGuard],
  },
  {
    path: "usuarios",
    loadComponent: () => import("./components/usuarios/usuarios.component").then((m) => m.UsuariosComponent),
    canActivate: [authGuard, roleGuard],
    data: { permisoRequerido: "eliminar" },
  },
  {
    path: "",
    redirectTo: "/login",
    pathMatch: "full",
  },
  {
    path: "**",
    redirectTo: "/login",
  },
]
