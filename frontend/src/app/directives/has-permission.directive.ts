import { Directive, Input, TemplateRef,ViewContainerRef,OnInit } from "@angular/core"
import { AuthService } from "../services/auth.service"

@Directive({
  selector: "[appHasPermission]",
  standalone: true,
})
export class HasPermissionDirective implements OnInit {
  private permiso = ""
  private hasView = false

  @Input() set appHasPermission(permiso: string) {
    this.permiso = permiso
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
    this.viewContainer.clear()
    this.hasView = false

    if (this.authService.tienePermiso(this.permiso)) {
      this.viewContainer.createEmbeddedView(this.templateRef)
      this.hasView = true
    }
  }
}
