import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RosterComponent} from './page/roster/roster.component';
import { AppComponent } from './app.component';
import {AuthComponent} from "./page/auth/auth.component";
import {PlayerComponent} from "./page/player/player.component";
import {IsSignedInGuard} from "./guard/is-signed-in.guard";

const routes: Routes = [
  { path: '', component: AuthComponent, data : { title: 'Login'} },
  { path: 'roster', component: RosterComponent, canActivate: [IsSignedInGuard], data : { title: 'Roster'} },
  { path: 'player', component: PlayerComponent, canActivate: [IsSignedInGuard], data : { title: 'Player'} },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
