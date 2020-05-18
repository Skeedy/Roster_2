import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RosterComponent} from './page/roster/roster.component';
import { AppComponent } from './app.component';
import {AuthComponent} from "./page/auth/auth.component";
import {PlayerComponent} from "./page/player/player.component";

const routes: Routes = [
  { path: '', component: AuthComponent, data : { title: 'Login'} },
  { path: 'roster', component: RosterComponent, data : { title: 'Roster'} },
  { path: 'player', component: PlayerComponent, data : { title: 'Player'} },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
