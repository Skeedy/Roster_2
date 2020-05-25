import {Component, Input, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {PlayerList} from "../../class/player-list";
import {RosterService} from "../../service/roster.service";
import {PlayerListService} from "../../service/player-list.service";
import {JobService} from "../../service/job.service";
import {Item} from "../../class/item";

@Component({
  selector: 'app-player-info',
  templateUrl: './player-info.component.html',
  styleUrls: ['./player-info.component.scss']
})
export class PlayerInfoComponent implements OnInit {
  @Input() player: Player;
  @Output() items: Item[];
  showPlayer = false;
  showDialog = false;
  idJobMain : number;
  showJob = false;
  isSub: boolean;
  jobOrder: number;
  ddbId: number;
  constructor(public jobServ: JobService) { }

  ngOnInit(): void {
    if(this.player.playerJobs[0]) {
      this.idJobMain = this.player.playerJobs[0].job.id
    }
  }
  getJobStuff() {
    if (this.player.playerJobs.length > 0) {
      this.showPlayer = !this.showPlayer;
      this.jobServ.getJobStuff(this.idJobMain).subscribe((data) => {
          this.items = data;
      })
    }
    else{
      this.showPlayer = !this.showPlayer;
      this.items = [];
    }
  }
}
