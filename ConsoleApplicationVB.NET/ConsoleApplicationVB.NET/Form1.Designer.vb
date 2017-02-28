<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Form1))
        Me.BezoekerBindingNavigator = New System.Windows.Forms.BindingNavigator(Me.components)
        Me.BindingNavigatorAddNewItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorCountItem = New System.Windows.Forms.ToolStripLabel()
        Me.BindingNavigatorDeleteItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorMoveFirstItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorMovePreviousItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorSeparator = New System.Windows.Forms.ToolStripSeparator()
        Me.BindingNavigatorPositionItem = New System.Windows.Forms.ToolStripTextBox()
        Me.BindingNavigatorSeparator1 = New System.Windows.Forms.ToolStripSeparator()
        Me.BindingNavigatorMoveNextItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorMoveLastItem = New System.Windows.Forms.ToolStripButton()
        Me.BindingNavigatorSeparator2 = New System.Windows.Forms.ToolStripSeparator()
        Me.BezoekerBindingNavigatorSaveItem = New System.Windows.Forms.ToolStripButton()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.IngelogdeBezoekerComboBox = New System.Windows.Forms.ComboBox()
        Me.IngelogdeBezoekerLabel = New System.Windows.Forms.Label()
        Me.VoornaamLabel = New System.Windows.Forms.Label()
        Me.VoornaamTextBox = New System.Windows.Forms.TextBox()
        Me.AchternaamTextbox = New System.Windows.Forms.TextBox()
        Me.EmailTextbox = New System.Windows.Forms.TextBox()
        Me.LandComboBox = New System.Windows.Forms.ComboBox()
        Me.LandLabel = New System.Windows.Forms.Label()
        Me.TelefoonTextbox = New System.Windows.Forms.TextBox()
        Me.TelefoonLabel = New System.Windows.Forms.Label()
        Me.OnderwerpLabel = New System.Windows.Forms.Label()
        Me.OnderwerpTextBox = New System.Windows.Forms.TextBox()
        Me.BerichtTextBox = New System.Windows.Forms.TextBox()
        Me.BerichtLabel = New System.Windows.Forms.Label()
        Me.CreationDateLabel = New System.Windows.Forms.Label()
        Me.CreationDateDateTimePicker = New System.Windows.Forms.DateTimePicker()
        Me.EmailLabel = New System.Windows.Forms.Label()
        Me.NaamTextbox = New System.Windows.Forms.Label()
        Me.VisitorBindingSource = New System.Windows.Forms.BindingSource(Me.components)
        Me.Overview = New System.Windows.Forms.Button()
        CType(Me.BezoekerBindingNavigator, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.BezoekerBindingNavigator.SuspendLayout()
        CType(Me.VisitorBindingSource, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'BezoekerBindingNavigator
        '
        Me.BezoekerBindingNavigator.AddNewItem = Me.BindingNavigatorAddNewItem
        Me.BezoekerBindingNavigator.CountItem = Me.BindingNavigatorCountItem
        Me.BezoekerBindingNavigator.DeleteItem = Me.BindingNavigatorDeleteItem
        Me.BezoekerBindingNavigator.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.BindingNavigatorMoveFirstItem, Me.BindingNavigatorMovePreviousItem, Me.BindingNavigatorSeparator, Me.BindingNavigatorPositionItem, Me.BindingNavigatorCountItem, Me.BindingNavigatorSeparator1, Me.BindingNavigatorMoveNextItem, Me.BindingNavigatorMoveLastItem, Me.BindingNavigatorSeparator2, Me.BindingNavigatorAddNewItem, Me.BindingNavigatorDeleteItem, Me.BezoekerBindingNavigatorSaveItem})
        Me.BezoekerBindingNavigator.Location = New System.Drawing.Point(0, 0)
        Me.BezoekerBindingNavigator.MoveFirstItem = Me.BindingNavigatorMoveFirstItem
        Me.BezoekerBindingNavigator.MoveLastItem = Me.BindingNavigatorMoveLastItem
        Me.BezoekerBindingNavigator.MoveNextItem = Me.BindingNavigatorMoveNextItem
        Me.BezoekerBindingNavigator.MovePreviousItem = Me.BindingNavigatorMovePreviousItem
        Me.BezoekerBindingNavigator.Name = "BezoekerBindingNavigator"
        Me.BezoekerBindingNavigator.PositionItem = Me.BindingNavigatorPositionItem
        Me.BezoekerBindingNavigator.Size = New System.Drawing.Size(358, 25)
        Me.BezoekerBindingNavigator.TabIndex = 0
        Me.BezoekerBindingNavigator.Text = "BindingNavigator1"
        '
        'BindingNavigatorAddNewItem
        '
        Me.BindingNavigatorAddNewItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorAddNewItem.Image = CType(resources.GetObject("BindingNavigatorAddNewItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorAddNewItem.Name = "BindingNavigatorAddNewItem"
        Me.BindingNavigatorAddNewItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorAddNewItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorAddNewItem.Text = "Add new"
        '
        'BindingNavigatorCountItem
        '
        Me.BindingNavigatorCountItem.Name = "BindingNavigatorCountItem"
        Me.BindingNavigatorCountItem.Size = New System.Drawing.Size(35, 22)
        Me.BindingNavigatorCountItem.Text = "of {0}"
        Me.BindingNavigatorCountItem.ToolTipText = "Total number of items"
        '
        'BindingNavigatorDeleteItem
        '
        Me.BindingNavigatorDeleteItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorDeleteItem.Image = CType(resources.GetObject("BindingNavigatorDeleteItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorDeleteItem.Name = "BindingNavigatorDeleteItem"
        Me.BindingNavigatorDeleteItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorDeleteItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorDeleteItem.Text = "Delete"
        '
        'BindingNavigatorMoveFirstItem
        '
        Me.BindingNavigatorMoveFirstItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorMoveFirstItem.Image = CType(resources.GetObject("BindingNavigatorMoveFirstItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorMoveFirstItem.Name = "BindingNavigatorMoveFirstItem"
        Me.BindingNavigatorMoveFirstItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorMoveFirstItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorMoveFirstItem.Text = "Move first"
        '
        'BindingNavigatorMovePreviousItem
        '
        Me.BindingNavigatorMovePreviousItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorMovePreviousItem.Image = CType(resources.GetObject("BindingNavigatorMovePreviousItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorMovePreviousItem.Name = "BindingNavigatorMovePreviousItem"
        Me.BindingNavigatorMovePreviousItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorMovePreviousItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorMovePreviousItem.Text = "Move previous"
        '
        'BindingNavigatorSeparator
        '
        Me.BindingNavigatorSeparator.Name = "BindingNavigatorSeparator"
        Me.BindingNavigatorSeparator.Size = New System.Drawing.Size(6, 25)
        '
        'BindingNavigatorPositionItem
        '
        Me.BindingNavigatorPositionItem.AccessibleName = "Position"
        Me.BindingNavigatorPositionItem.AutoSize = False
        Me.BindingNavigatorPositionItem.Name = "BindingNavigatorPositionItem"
        Me.BindingNavigatorPositionItem.Size = New System.Drawing.Size(50, 23)
        Me.BindingNavigatorPositionItem.Text = "0"
        Me.BindingNavigatorPositionItem.ToolTipText = "Current position"
        '
        'BindingNavigatorSeparator1
        '
        Me.BindingNavigatorSeparator1.Name = "BindingNavigatorSeparator1"
        Me.BindingNavigatorSeparator1.Size = New System.Drawing.Size(6, 25)
        '
        'BindingNavigatorMoveNextItem
        '
        Me.BindingNavigatorMoveNextItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorMoveNextItem.Image = CType(resources.GetObject("BindingNavigatorMoveNextItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorMoveNextItem.Name = "BindingNavigatorMoveNextItem"
        Me.BindingNavigatorMoveNextItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorMoveNextItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorMoveNextItem.Text = "Move next"
        '
        'BindingNavigatorMoveLastItem
        '
        Me.BindingNavigatorMoveLastItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BindingNavigatorMoveLastItem.Image = CType(resources.GetObject("BindingNavigatorMoveLastItem.Image"), System.Drawing.Image)
        Me.BindingNavigatorMoveLastItem.Name = "BindingNavigatorMoveLastItem"
        Me.BindingNavigatorMoveLastItem.RightToLeftAutoMirrorImage = True
        Me.BindingNavigatorMoveLastItem.Size = New System.Drawing.Size(23, 22)
        Me.BindingNavigatorMoveLastItem.Text = "Move last"
        '
        'BindingNavigatorSeparator2
        '
        Me.BindingNavigatorSeparator2.Name = "BindingNavigatorSeparator2"
        Me.BindingNavigatorSeparator2.Size = New System.Drawing.Size(6, 25)
        '
        'BezoekerBindingNavigatorSaveItem
        '
        Me.BezoekerBindingNavigatorSaveItem.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.BezoekerBindingNavigatorSaveItem.Image = CType(resources.GetObject("BezoekerBindingNavigatorSaveItem.Image"), System.Drawing.Image)
        Me.BezoekerBindingNavigatorSaveItem.Name = "BezoekerBindingNavigatorSaveItem"
        Me.BezoekerBindingNavigatorSaveItem.Size = New System.Drawing.Size(23, 22)
        Me.BezoekerBindingNavigatorSaveItem.Text = "Save Data"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(163, 367)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(130, 22)
        Me.Button1.TabIndex = 19
        Me.Button1.Text = "Insert"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'IngelogdeBezoekerComboBox
        '
        Me.IngelogdeBezoekerComboBox.FormattingEnabled = True
        Me.IngelogdeBezoekerComboBox.Location = New System.Drawing.Point(163, 51)
        Me.IngelogdeBezoekerComboBox.Name = "IngelogdeBezoekerComboBox"
        Me.IngelogdeBezoekerComboBox.Size = New System.Drawing.Size(121, 21)
        Me.IngelogdeBezoekerComboBox.TabIndex = 20
        '
        'IngelogdeBezoekerLabel
        '
        Me.IngelogdeBezoekerLabel.AutoSize = True
        Me.IngelogdeBezoekerLabel.Location = New System.Drawing.Point(37, 54)
        Me.IngelogdeBezoekerLabel.Name = "IngelogdeBezoekerLabel"
        Me.IngelogdeBezoekerLabel.Size = New System.Drawing.Size(102, 13)
        Me.IngelogdeBezoekerLabel.TabIndex = 21
        Me.IngelogdeBezoekerLabel.Text = "Ingelogde Bezoeker"
        '
        'VoornaamLabel
        '
        Me.VoornaamLabel.AutoSize = True
        Me.VoornaamLabel.Location = New System.Drawing.Point(40, 88)
        Me.VoornaamLabel.Name = "VoornaamLabel"
        Me.VoornaamLabel.Size = New System.Drawing.Size(55, 13)
        Me.VoornaamLabel.TabIndex = 22
        Me.VoornaamLabel.Text = "Voornaam"
        '
        'VoornaamTextBox
        '
        Me.VoornaamTextBox.Location = New System.Drawing.Point(163, 88)
        Me.VoornaamTextBox.Name = "VoornaamTextBox"
        Me.VoornaamTextBox.Size = New System.Drawing.Size(121, 20)
        Me.VoornaamTextBox.TabIndex = 23
        '
        'AchternaamTextbox
        '
        Me.AchternaamTextbox.Location = New System.Drawing.Point(163, 129)
        Me.AchternaamTextbox.Name = "AchternaamTextbox"
        Me.AchternaamTextbox.Size = New System.Drawing.Size(121, 20)
        Me.AchternaamTextbox.TabIndex = 24
        '
        'EmailTextbox
        '
        Me.EmailTextbox.Location = New System.Drawing.Point(163, 165)
        Me.EmailTextbox.Name = "EmailTextbox"
        Me.EmailTextbox.Size = New System.Drawing.Size(121, 20)
        Me.EmailTextbox.TabIndex = 25
        '
        'LandComboBox
        '
        Me.LandComboBox.FormattingEnabled = True
        Me.LandComboBox.Location = New System.Drawing.Point(163, 203)
        Me.LandComboBox.Name = "LandComboBox"
        Me.LandComboBox.Size = New System.Drawing.Size(121, 21)
        Me.LandComboBox.TabIndex = 26
        '
        'LandLabel
        '
        Me.LandLabel.AutoSize = True
        Me.LandLabel.Location = New System.Drawing.Point(43, 211)
        Me.LandLabel.Name = "LandLabel"
        Me.LandLabel.Size = New System.Drawing.Size(31, 13)
        Me.LandLabel.TabIndex = 27
        Me.LandLabel.Text = "Land"
        '
        'TelefoonTextbox
        '
        Me.TelefoonTextbox.Location = New System.Drawing.Point(163, 246)
        Me.TelefoonTextbox.Name = "TelefoonTextbox"
        Me.TelefoonTextbox.Size = New System.Drawing.Size(121, 20)
        Me.TelefoonTextbox.TabIndex = 28
        '
        'TelefoonLabel
        '
        Me.TelefoonLabel.AutoSize = True
        Me.TelefoonLabel.Location = New System.Drawing.Point(40, 252)
        Me.TelefoonLabel.Name = "TelefoonLabel"
        Me.TelefoonLabel.Size = New System.Drawing.Size(49, 13)
        Me.TelefoonLabel.TabIndex = 29
        Me.TelefoonLabel.Text = "Telefoon"
        '
        'OnderwerpLabel
        '
        Me.OnderwerpLabel.AutoSize = True
        Me.OnderwerpLabel.Location = New System.Drawing.Point(40, 285)
        Me.OnderwerpLabel.Name = "OnderwerpLabel"
        Me.OnderwerpLabel.Size = New System.Drawing.Size(59, 13)
        Me.OnderwerpLabel.TabIndex = 30
        Me.OnderwerpLabel.Text = "Onderwerp"
        '
        'OnderwerpTextBox
        '
        Me.OnderwerpTextBox.Location = New System.Drawing.Point(163, 282)
        Me.OnderwerpTextBox.Name = "OnderwerpTextBox"
        Me.OnderwerpTextBox.Size = New System.Drawing.Size(100, 20)
        Me.OnderwerpTextBox.TabIndex = 32
        '
        'BerichtTextBox
        '
        Me.BerichtTextBox.Location = New System.Drawing.Point(163, 308)
        Me.BerichtTextBox.Name = "BerichtTextBox"
        Me.BerichtTextBox.Size = New System.Drawing.Size(100, 20)
        Me.BerichtTextBox.TabIndex = 33
        '
        'BerichtLabel
        '
        Me.BerichtLabel.AutoSize = True
        Me.BerichtLabel.Location = New System.Drawing.Point(40, 314)
        Me.BerichtLabel.Name = "BerichtLabel"
        Me.BerichtLabel.Size = New System.Drawing.Size(40, 13)
        Me.BerichtLabel.TabIndex = 34
        Me.BerichtLabel.Text = "Bericht"
        '
        'CreationDateLabel
        '
        Me.CreationDateLabel.AutoSize = True
        Me.CreationDateLabel.Location = New System.Drawing.Point(43, 341)
        Me.CreationDateLabel.Name = "CreationDateLabel"
        Me.CreationDateLabel.Size = New System.Drawing.Size(69, 13)
        Me.CreationDateLabel.TabIndex = 35
        Me.CreationDateLabel.Text = "CreationDate"
        '
        'CreationDateDateTimePicker
        '
        Me.CreationDateDateTimePicker.Location = New System.Drawing.Point(158, 335)
        Me.CreationDateDateTimePicker.Name = "CreationDateDateTimePicker"
        Me.CreationDateDateTimePicker.Size = New System.Drawing.Size(200, 20)
        Me.CreationDateDateTimePicker.TabIndex = 36
        '
        'EmailLabel
        '
        Me.EmailLabel.AutoSize = True
        Me.EmailLabel.Location = New System.Drawing.Point(46, 171)
        Me.EmailLabel.Name = "EmailLabel"
        Me.EmailLabel.Size = New System.Drawing.Size(35, 13)
        Me.EmailLabel.TabIndex = 37
        Me.EmailLabel.Text = "E-mail"
        '
        'NaamTextbox
        '
        Me.NaamTextbox.AutoSize = True
        Me.NaamTextbox.Location = New System.Drawing.Point(40, 129)
        Me.NaamTextbox.Name = "NaamTextbox"
        Me.NaamTextbox.Size = New System.Drawing.Size(64, 13)
        Me.NaamTextbox.TabIndex = 38
        Me.NaamTextbox.Text = "Achternaam"
        '
        'Overview
        '
        Me.Overview.Location = New System.Drawing.Point(12, 367)
        Me.Overview.Name = "Overview"
        Me.Overview.Size = New System.Drawing.Size(102, 22)
        Me.Overview.TabIndex = 39
        Me.Overview.Text = "Overview Data"
        Me.Overview.UseVisualStyleBackColor = True
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(358, 409)
        Me.Controls.Add(Me.Overview)
        Me.Controls.Add(Me.NaamTextbox)
        Me.Controls.Add(Me.EmailLabel)
        Me.Controls.Add(Me.CreationDateDateTimePicker)
        Me.Controls.Add(Me.CreationDateLabel)
        Me.Controls.Add(Me.BerichtLabel)
        Me.Controls.Add(Me.BerichtTextBox)
        Me.Controls.Add(Me.OnderwerpTextBox)
        Me.Controls.Add(Me.OnderwerpLabel)
        Me.Controls.Add(Me.TelefoonLabel)
        Me.Controls.Add(Me.TelefoonTextbox)
        Me.Controls.Add(Me.LandLabel)
        Me.Controls.Add(Me.LandComboBox)
        Me.Controls.Add(Me.EmailTextbox)
        Me.Controls.Add(Me.AchternaamTextbox)
        Me.Controls.Add(Me.VoornaamTextBox)
        Me.Controls.Add(Me.VoornaamLabel)
        Me.Controls.Add(Me.IngelogdeBezoekerLabel)
        Me.Controls.Add(Me.IngelogdeBezoekerComboBox)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.BezoekerBindingNavigator)
        Me.Name = "Form1"
        Me.Text = "Form1"
        CType(Me.BezoekerBindingNavigator, System.ComponentModel.ISupportInitialize).EndInit()
        Me.BezoekerBindingNavigator.ResumeLayout(False)
        Me.BezoekerBindingNavigator.PerformLayout()
        CType(Me.VisitorBindingSource, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
   
    Friend WithEvents BezoekerBindingNavigator As System.Windows.Forms.BindingNavigator
    Friend WithEvents BindingNavigatorAddNewItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorCountItem As System.Windows.Forms.ToolStripLabel
    Friend WithEvents BindingNavigatorDeleteItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorMoveFirstItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorMovePreviousItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorSeparator As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents BindingNavigatorPositionItem As System.Windows.Forms.ToolStripTextBox
    Friend WithEvents BindingNavigatorSeparator1 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents BindingNavigatorMoveNextItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorMoveLastItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents BindingNavigatorSeparator2 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents BezoekerBindingNavigatorSaveItem As System.Windows.Forms.ToolStripButton
    Friend WithEvents Button1 As System.Windows.Forms.Button

    Friend WithEvents VisitorBindingSource As System.Windows.Forms.BindingSource
   
    Friend WithEvents IngelogdeBezoekerComboBox As System.Windows.Forms.ComboBox
    Friend WithEvents IngelogdeBezoekerLabel As System.Windows.Forms.Label
    Friend WithEvents VoornaamLabel As System.Windows.Forms.Label
    Friend WithEvents VoornaamTextBox As System.Windows.Forms.TextBox
    Friend WithEvents AchternaamTextbox As System.Windows.Forms.TextBox
    Friend WithEvents EmailTextbox As System.Windows.Forms.TextBox
    Friend WithEvents LandComboBox As System.Windows.Forms.ComboBox
    Friend WithEvents LandLabel As System.Windows.Forms.Label
    Friend WithEvents TelefoonTextbox As System.Windows.Forms.TextBox
    Friend WithEvents TelefoonLabel As System.Windows.Forms.Label
    Friend WithEvents OnderwerpLabel As System.Windows.Forms.Label
    Friend WithEvents OnderwerpTextBox As System.Windows.Forms.TextBox
    Friend WithEvents BerichtTextBox As System.Windows.Forms.TextBox
    Friend WithEvents BerichtLabel As System.Windows.Forms.Label
    Friend WithEvents CreationDateLabel As System.Windows.Forms.Label
    Friend WithEvents CreationDateDateTimePicker As System.Windows.Forms.DateTimePicker
    Friend WithEvents EmailLabel As System.Windows.Forms.Label
    Friend WithEvents NaamTextbox As System.Windows.Forms.Label
    Friend WithEvents Overview As System.Windows.Forms.Button
End Class
