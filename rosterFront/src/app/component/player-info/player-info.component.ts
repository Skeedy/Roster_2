import {Component, Input, OnInit} from '@angular/core';
import {Player} from "../../class/player";
import {PlayerList} from "../../class/player-list";
import {RosterService} from "../../service/roster.service";
import {PlayerListService} from "../../service/player-list.service";

@Component({
  selector: 'app-player-info',
  templateUrl: './player-info.component.html',
  styleUrls: ['./player-info.component.scss']
})
export class PlayerInfoComponent implements OnInit {
  @Input() player: Player;
  showPlayer = false;
  showDialog = false;
  idJobMain : number;
  showJob = false;
  isSub: boolean;
  jobOrder: number;
  ddbId: number;
  constructor() { }

  ngOnInit(): void {
    this.idJobMain = this.player.playerJobs[0].job.id
  }

}
