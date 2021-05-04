import {
  AfterViewInit,
  Component,
  ComponentFactoryResolver, Input,
  OnInit,
  ViewChild,
  ViewContainerRef
} from '@angular/core';
import {Player} from "../../class/player";
import {AddPlayerComponent} from "../../component/add-player/add-player.component";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";
import {Roster} from "../../class/roster";
import {JobService} from "../../service/job.service";
import {Router} from "@angular/router";


@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit, AfterViewInit{
  constructor(
              public rosterServ: RosterService,
              private router: Router,
              public jobServ: JobService) {
  }

  ngOnInit(): void {
    if (this.rosterServ.isConnected()) {
      this.rosterServ.getRoster().subscribe(_ => {
        console.log(this.rosterServ._rosterSub.value.player.length)
        },
        _ => {
          this.router.navigate(['/']);
          this.rosterServ.logout()
        });
      this.jobServ.getJobs();
    }
    else{
      this.router.navigate(['/']);
    }
  }
  ngAfterViewInit() {
  }


}
