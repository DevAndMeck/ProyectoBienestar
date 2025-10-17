import { Component, type OnInit } from "@angular/core"
import { CommonModule } from "@angular/common"
import { Router, RouterModule } from "@angular/router"
import { AuthService } from "../../services/auth.service"
import { Usuario } from "../../models/usuario.model"

@Component({
  selector: "app-dashboard",
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: "./dashboard.component.html",
  styleUrls: ["./dashboard.component.css"],
})
export class DashboardComponent implements OnInit {
  usuario: Usuario | null = null

  constructor(
    public authService: AuthService,
    private router: Router,
  ) {}

  ngOnInit(): void {
    this.usuario = this.authService.getCurrentUser()
  }

  logout(): void {
    this.authService.logout()
    this.router.navigate(["/login"])
  }
}
