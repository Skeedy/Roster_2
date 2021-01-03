import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RosterComponent} from './page/roster/roster.component';
import { AppComponent } from './app.component';
import {AuthComponent} from "./page/auth/auth.component";
import {PlayerComponent} from "./page/player/player.component";
import {IsSignedInGuard} from "./guard/is-signed-in.guard";
import {ItemComponent} from "./page/item/item.component";

const routes: Routes = [
  { path: '', component: AuthComponent, data : { title: 'Login'} },
  { path: 'roster', component: RosterComponent, canActivate: [IsSignedInGuard], data : { title: 'Roster'} },
  { path: 'player', component: PlayerComponent, canActivate: [IsSignedInGuard], data : { title: 'Player'} },
  { path: 'item', component: ItemComponent, canActivate: [IsSignedInGuard], data : { title: 'Item'} },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
