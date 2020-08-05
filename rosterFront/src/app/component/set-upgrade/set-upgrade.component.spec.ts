import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SetUpgradeComponent } from './set-upgrade.component';

describe('SetUpgradeComponent', () => {
  let component: SetUpgradeComponent;
  let fixture: ComponentFixture<SetUpgradeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SetUpgradeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SetUpgradeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
