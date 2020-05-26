import { Injectable } from '@angular/core';
import {CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router} from '@angular/router';
import { Observable } from 'rxjs';
import {RosterService} from "../service/roster.service";

@Injectable({
  providedIn: 'root'
})
export class IsSignedInGuard implements CanActivate {
  constructor(private rosterServ: RosterService, private router: Router) { }
  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    const isSignedIn = this.rosterServ.isConnected();
    if (isSignedIn !== true) {
      this.router.navigate(['/']);
      this.rosterServ.logout();
    }
    return isSignedIn;
  }
}
