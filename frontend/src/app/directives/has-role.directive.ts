import { Directive, Input, TemplateRef, ViewContainerRef, OnInit } from "@angular/core"
import { AuthService } from "../services/auth.service"

@Directive({
  selector: "[appHasRole]",
  standalone: true,
})
export class HasRoleDirective implements OnInit {
  private rol = ""

  @Input() set appHasRole(rol: string) {
    this.rol = rol
    this.updateView()
  }

  constructor(
    private templateRef: TemplateRef<any>,
    private viewContainer: ViewContainerRef,
    private authService: AuthService,
  ) {}

  ngOnInit(): void {
    this.updateView()
  }

  private updateView(): void {
    const usuario = this.authService.getCurrentUser()
    if (usuario && usuario.rol_nombre === this.rol) {
      this.viewContainer.createEmbeddedView(this.templateRef)
    } else {
      this.viewContainer.clear()
    }
  }
}
