import { Component } from '@angular/core';
import {Roster} from "./class/roster";
import {RosterService} from "./service/roster.service";
import {Router} from "@angular/router";
import {SoundService} from "./service/sound.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'FFXIV Roster';
  roster: Roster|null;
  constructor(
    private rosterServ: RosterService,
    private router: Router,
    public soundService: SoundService
  ){  }
  isConnected(): boolean {
    this.roster = this.rosterServ.currentUser;
    return this.rosterServ.isConnected();
  }
  logout(): void {
    this.soundService.playLogOut();
    this.rosterServ.logout();
    this.router.navigate(['/']);
  }
}
