Imports System.Data.SqlClient
Imports System.Windows.Forms

Public Class OverviewData



    Private Sub BezoekerBindingNavigatorSaveItem_Click(sender As Object, e As EventArgs) Handles BezoekerBindingNavigatorSaveItem.Click
        Me.Validate()
        Me.BezoekerBindingSource.EndEdit()


    End Sub

    Private Sub OverviewData_Load(sender As Object, e As EventArgs) Handles MyBase.Load
       
        DataGridView1.DataSource = DBModel.BezoekerContext.Bezoekers.ToList()

    End Sub

    

    Private Sub SearchButton_Click(sender As Object, e As EventArgs) Handles SearchButton.Click

        Try
            DataGridView1.DataSource = _
                DBModel.BezoekerContext.Bezoekers.Where(Function(s) s.Ingelogde_Bezoeker.Contains(SearchTextBox.Text) _
                                                  Or s.Voornaam.Contains(SearchTextBox.Text) _
                                                    Or s.Achternaam.Contains(SearchTextBox.Text) _
                                                    Or s.Email.Contains(SearchTextBox.Text) Or s.Land.Contains(SearchTextBox.Text) _
                                                     Or s.Telefoon.Contains(SearchTextBox.Text) Or s.Onderwerp.Contains(SearchTextBox.Text) _
                                                    Or s.Bericht.Contains(SearchTextBox.Text) Or s.CreationDate.Contains(SearchTextBox.Text)).ToList()



        Catch ex As SqlException
            MessageBox.Show(ex.Message
                            )
        Catch nullpoint As NullReferenceException
            MessageBox.Show("in search zit de nullpointer")
        End Try


    End Sub

    Private Sub EditButton_Click(sender As Object, e As EventArgs) Handles EditButton.Click

        Dim Form2 As New Form2

        Form2.IDTextBox.Text = DataGridView1.CurrentRow.Cells(0).Value.ToString()
        Form2.IngelogdeBezoekerComboBox.Text = DataGridView1.CurrentRow.Cells(1).Value.ToString()
        Form2.VoornaamTextBox.Text = DataGridView1.CurrentRow.Cells(2).Value.ToString()
        Form2.AchternaamTextbox.Text = DataGridView1.CurrentRow.Cells(3).Value.ToString()
        Form2.EmailTextbox.Text = DataGridView1.CurrentRow.Cells(4).Value.ToString()
        Form2.LandComboBox.Text = DataGridView1.CurrentRow.Cells(5).Value.ToString()
        Form2.TelefoonTextbox.Text = DataGridView1.CurrentRow.Cells(6).Value.ToString()
        Form2.OnderwerpTextBox.Text = DataGridView1.CurrentRow.Cells(7).Value.ToString()
        Form2.BerichtTextBox.Text = DataGridView1.CurrentRow.Cells(8).Value.ToString()
        Form2.CreationDateDateTimePicker.Text = DataGridView1.CurrentRow.Cells(9).Value.ToString()

        Form2.Show()

    End Sub

    
    Private Sub DeleteButton_Click(sender As Object, e As EventArgs) Handles DeleteButton.Click
        Try

            Dim index As Integer

            index = DataGridView1.CurrentCell.RowIndex + 1

            DBModel.DeleteRecord(index)

            DataGridView1.DataSource = DBModel.BezoekerContext.Bezoekers.ToList()


        Catch sqlex As SqlException
            MessageBox.Show(sqlex.Message
                            )
        Catch nullpoint As NullReferenceException
            MessageBox.Show("in delete zit de nullpointer")

        End Try

    End Sub


    Private Sub InsertButton_Click(sender As Object, e As EventArgs) Handles InsertButton.Click

        Dim insertForm As New Form1

        insertForm.Show()

    End Sub
End Class