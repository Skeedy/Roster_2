import {Component, Input, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {PlayerList} from "../../class/player-list";
import {RosterService} from "../../service/roster.service";
import {PlayerListService} from "../../service/player-list.service";
import {JobService} from "../../service/job.service";
import {Item} from "../../class/item";
import {Wishitem} from "../../class/wishitem";
import {WhishitemService} from "../../service/whishitem.service";
import {CurrentstuffService} from "../../service/currentstuff.service";
import {Currentstuff} from "../../class/currentstuff";
import {ErrorService} from "../../service/error.service";
import {Job} from "../../class/job";

@Component({
  selector: 'app-player-info',
  templateUrl: './player-info.component.html',
  styleUrls: ['./player-info.component.scss']
})
export class PlayerInfoComponent implements OnInit {
  // injecte ses données dans le component enfant
  @Input() player: Player;
  @Input() items: Item[];
  // si passe à true, affichera le component "player-show"
  showPlayer = false;
  idJobMain : number;
  // si passe à true, affichera le component "jobs"
  showJob = false;
  isSub: boolean;
  // variable qui s'attend à récupérer une instance de wishItem
  wishItem: Wishitem;
  currentStuff: Currentstuff;
  jobOrder: number;
  // identifiant du job dans la base de données
  ddbId: number;
  jobName: string;
  constructor(public jobServ: JobService,
              public wishitemServ: WhishitemService,
              public currentServ: CurrentstuffService,
              public errorServ: ErrorService) { }

  ngOnInit(): void {
    if(this.player.playerJobs[0]) {
      this.idJobMain = this.player.playerJobs[0].job.id;
    }
  }
  noJobSet(){
    this.errorServ.getError(this.player.name + ' has no job defined.', 'Please select at least one job to proceed')
  }
  getJobStuff(wishId, StuffId) {
    if (this.player.playerJobs.length > 0) {
      // récupère l'équipement que le job peut équiper.
      this.jobServ.getJobStuff(this.idJobMain).subscribe((data) => {
          this.items = data;
      })
      // récupère sa wishlist de son job
      this.wishitemServ.getWishItem(wishId).subscribe((data)=>{
        this.wishItem = data;
      })
      // récupère son currentstuff de son job
      this.currentServ.getCurrentItem(StuffId).subscribe((data)=>{
        this.currentStuff = data;
      })
      // affiche donc le component "player-show"
      this.showPlayer = !this.showPlayer;
    }
    else{
      this.showPlayer = !this.showPlayer;
      this.items = [];
    }
  }
}
