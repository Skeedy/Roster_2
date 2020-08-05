import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UpgradePlayerJobComponent } from './upgrade-player-job.component';

describe('UpgradePlayerJobComponent', () => {
  let component: UpgradePlayerJobComponent;
  let fixture: ComponentFixture<UpgradePlayerJobComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UpgradePlayerJobComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UpgradePlayerJobComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
