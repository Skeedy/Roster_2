import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditRosterComponent } from './edit-roster.component';

describe('EditRosterComponent', () => {
  let component: EditRosterComponent;
  let fixture: ComponentFixture<EditRosterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditRosterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditRosterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
